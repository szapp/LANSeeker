;mpress
;
; appurl.ahk
; Author: szapp
; Heavily modfied from:
;
; Application URL v1.0 by Jeff Sherk
;
; Will run a program that you pass in as a parameter (command line argument).
; Specifically created to be used with URL Protocol appurl://
;
; EXAMPLE:
;  You can type appurl://path/to/myapp.exe in the address bar of your browser to launch the application
;
; See these threads:
;  http://www.autohotkey.com/forum/viewtopic.php?p=477917
;  http://www.autohotkey.com/forum/viewtopic.php?t=76997
;  http://msdn.microsoft.com/en-us/library/aa767914(v=vs.85).aspx
;  http://stackoverflow.com/questions/2330545/is-it-possible-to-open-custom-url-scheme-with-google-chrome
;
; Requires adding the following Registry Entry to work. You can copy and paste whats between the dashed lines
;  into a file called: appurl.reg  Just remember to remove all the semi-colons; at the beginning of the lines.
;-------------------------------------------------------------------
;Windows Registry Editor Version 5.00

;[HKEY_CLASSES_ROOT\appurl]
;@="URL:AutoHotKey AppURL Protocol"
;"URL Protocol"=""

;[HKEY_CLASSES_ROOT\appurl\DefaultIcon]
;@="appurl.exe,1"

;[HKEY_CLASSES_ROOT\appurl\shell]

;[HKEY_CLASSES_ROOT\appurl\shell\open]

;[HKEY_CLASSES_ROOT\appurl\shell\open\command]
;@="\"C:\\Program Files\\AutoHotKeyAppURL\\appurl.exe\" \"%1\""
;-------------------------------------------------------------------

if 0 != 1 ;Check %0% to see how many parameters were passed in
{
    msgbox ERROR: There are %0% parameters. There should be 1 parameter exactly.
}
else
{
    param = %1%  ;Fetch the contents of the command line argument

    appurl := "appurl://" ; This should be the URL Protocol that you registered in the Windows Registry

    IfInString, param, %appurl%
    {
        arglen := StrLen(param) ;Length of entire argument
        applen := StrLen(appurl) ;Length of appurl
        len := arglen - applen ;Length of argument less appurl
        StringRight, param, param, len ; Remove appurl portion from the beginning of parameter
    }

    Run, %param%

}
