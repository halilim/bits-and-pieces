<!-- 
    METADATA 
    TYPE="typelib" 
    UUID="CD000000-8B95-11D1-82DB-00C04FB1625D"  
    NAME="CDO for Windows 2000 Library" 
-->
<%  
sub SendMail(strFrom, strTo, strSubject, strBody, encoding)
    Set cdoConfig = CreateObject("CDO.Configuration")  
 
    With cdoConfig.Fields  
        .Item(cdoSendUsingMethod) = cdoSendUsingPort  
        .Item(cdoSMTPServer) = "localhost"  
        .Update  
    End With 
 
    Set cdoMessage = CreateObject("CDO.Message")  
 
    With cdoMessage 
        Set .Configuration = cdoConfig 
        .bodyPart.Charset = encoding 
        .From = strFrom
        .To = strTo
        .Subject = strSubject
        .HTMLBody  = strBody
        .Send
    End With 
 
    Set cdoMessage = Nothing  
    Set cdoConfig = Nothing  
end sub
%>

Örnek Kullanım:
<%
body = "<html><head><meta http-equiv=""Content-Type"" content=""text/html; charset=iso-8859-9""><title>Konu</title></head><body>"
body = body & "HTML Mesaj"
body = body & "</body></html>"
SendMail "Örnek gönderen <sender@example.org>", "Gidecek Kişi <receiver@example.org>", "Konu", body, "iso-8859-9"
