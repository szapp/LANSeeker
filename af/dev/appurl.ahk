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

#SingleInstance, ignore
#NoEnv

if 0 != 1 ; Check %0% to see how many parameters were passed in
{
    MsgBox, ERROR: There are %0% parameters. There should be 1 parameter exactly.
    ExitApp
}

param = %1%  ; Fetch the contents of the command line argument

if (param = "-uninst")
    Gosub, uninst

filen := SubStr(param, InStr(param, "\", 0, 0)+1)
TrayTip, Starting %filen%, Please wait..., , 1

appurl := "appurl://" ; This should be the URL Protocol that you registered in the Windows Registry

IfInString, param, %appurl%
{
    arglen := StrLen(param) ;Length of entire argument
    applen := StrLen(appurl) ;Length of appurl
    len := arglen - applen ;Length of argument less appurl
    StringRight, param, param, len ; Remove appurl portion from the beginning of parameter
}

Run, %param%, , UseErrorLevel
if ErrorLevel
{
    TrayTip, %filen% not found!, Please try again, , 3
    Sleep, 5000
}
ExitApp

;; UNINSTALL
uninst:

if not A_IsAdmin
{
    params := "-uninst"
    Run *RunAs %A_ScriptFullPath% /restart %params%, %A_WorkingDir%, UseErrorLevel
    Sleep, 2000 ; If the current instance is not replaced after two seconds, it probably failed
    MsgBox, 16, Initialization failed, The program could not be started. Please restart the application with administrative rights!
    ExitApp, 1 ; Exit current instance
}

SetRegView 32 ; Wow6432Node\
MsgBox, 36, Uninstall Setup Launcher, Are you sure to uninstall Setup Launcher?
IfMsgBox No
    ExitApp

uninst1 := "* R"
RegDelete, HKEY_CLASSES_ROOT, appurl
if ErrorLevel
{
    MsgBox, 48, Registry error, Could not remove registry entries properly!
    uninst1 := "x Not r"
}
RegRead, tmppath, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, InstallLocation
RegDelete, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher

MsgBox, 32, Setup Launcher uninstalled, The Setup Launcher was uninstalled!`n`n %uninst1%emoved from registry.
del_com := "ping 127.0.0.1 -n 2 > nul`nrmdir /S /Q """ tmppath """`ndel """ A_Temp "\delsetup.bat"""
FileDelete, %A_Temp%\delsetup.bat
FileAppend, %del_com%, %A_Temp%\delsetup.bat
Run, %A_Temp%\delsetup.bat, %A_Temp%, Hide UseErrorlevel
ExitApp
