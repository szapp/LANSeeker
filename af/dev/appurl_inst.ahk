; mpress
#SingleInstance, ignore
#NoTrayIcon
#NoEnv

if not A_IsAdmin
{
	params := ""
	Run *RunAs %A_ScriptFullPath% /restart %params%, %A_WorkingDir%, UseErrorLevel
	Sleep, 2000 ; If the current instance is not replaced after two seconds, it probably failed
	MsgBox, 16, Initialization failed, The program could not be started. Please restart the application with administrative rights!
	ExitApp, 1 ; Exit current instance
}

host := "PC-HOST" ; Enter host here: Network-name of the machine running the web-interface
Author := "szapp"
Version = 7.0.0.1
Projectname := "Setup Launcher"
FileGetSize, Projectsize, %A_ScriptFullPath%, K

SetRegView 32 ; Wow6432Node\
RegRead, instVersion, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, DisplayVersion
RegRead, firefox_inst, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, FirefoxIntegrated
if (!firefox_inst)
	firefox_inst := ""
if (instVersion >= Version)
{
	; Already installed
	; MsgBox, Already up-to-date ; Remove
	GoSub, ToExit
}

; TODO: Adjust path
path := A_ProgramFiles "\SetupLauncher\appurl.exe"
FileCreateDir, % SubStr(path, 1, InStr(path, "\", 0, 0))
; TODO: Install appurl.exe
FileInstall, appurl.exe, %path%, 1

subkeys := [], keys := [], values := []
subkeys.Insert("appurl")
   keys.Insert(""), values.Insert("URL:appurl protocol")
subkeys.Insert("appurl")
   keys.Insert("URL Protocol"), values.Insert("")
subkeys.Insert("appurl\DefaultIcon")
   keys.Insert(""), values.Insert("appurl.exe")
subkeys.Insert("appurl\Shell")
   keys.Insert(""), values.Insert("")
subkeys.Insert("appurl\Shell\Open")
   keys.Insert(""), values.Insert("Setup Launcher")
subkeys.Insert("appurl\Shell\Open\Command")
   keys.Insert(""), values.Insert("""" path """ ""%1""")

Loop, % subkeys.maxIndex()
{
	RegWrite, REG_SZ, HKEY_CLASSES_ROOT, % subkeys[A_Index], % keys[A_Index], % values[A_Index]
	if ErrorLevel
	{
		MsgBox, 16, Registry error, Could not create registry entries properly!
		ExitApp, 11
	}
}

; Integrate into firefox

i = 0
While WinExist("ahk_exe firefox.exe")
{
	if (i >= 1)
		MsgBox, 48, Setup Launcher: Close Mozilla Firefox, To continue with the setup process, please close Mozilla Firefox
	WinClose, ahk_exe firefox.exe
	i++
	Sleep, 7000
}

d_path := A_AppData "\Mozilla\Firefox\Profiles\"

addto =
(
		
	  <RDF:Description RDF:about="urn:scheme:appurl"
	                 NC:value="appurl">
	  <NC:handlerProp RDF:resource="urn:scheme:handler:appurl"/>
	</RDF:Description>
	<RDF:Description RDF:about="urn:handler:local:%path%"
	                 NC:prettyName="Setup Launcher"
	                 NC:path="%path%" />
	<RDF:Description RDF:about="urn:scheme:handler:appurl"
	                 NC:alwaysAsk="false">
	  <NC:possibleApplication RDF:resource="urn:handler:local:%path%"/>
	  <NC:externalApplication RDF:resource="urn:scheme:externalApplication:appurl"/>
	</RDF:Description>
	<RDF:Description RDF:about="urn:scheme:externalApplication:appurl"
	                 NC:prettyName="Setup Launcher"
	                 NC:path="%path%" />

</RDF:RDF>
)

Loop, %d_path%*.*, 2, 0
{
	if InStr(firefox_inst, A_LoopFileName . "|")
		Continue
	; %A_LoopFileLongPath%\mimeTypes.rdf
	FileCopy, %A_LoopFileLongPath%\mimeTypes.rdf, %A_LoopFileLongPath%\mimeTypes.rdf.BAK, 1
	FileRead, Contents, %A_LoopFileLongPath%\mimeTypes.rdf
	if ErrorLevel
		Continue
	StringReplace, Contents, Contents, <RDF:Seq RDF:about="urn:schemes:root">, <RDF:Seq RDF:about="urn:schemes:root">`n    <RDF:li RDF:resource="urn:scheme:appurl"/>
	StringReplace, Contents, Contents, </RDF:RDF>, %addto%
	FileDelete, %A_LoopFileLongPath%\mimeTypes.rdf
	FileAppend, %Contents%, %A_LoopFileLongPath%\mimeTypes.rdf
	firefox_inst .= A_LoopFileName . "|"
}

; Register for uninstall
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, DisplayIcon, "%path%"
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, DisplayName, %Projectname%
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, DisplayVersion, %Version%
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, InstallLocation, % SubStr(path, 1, InStr(path, "\", 0, 0))
RegWrite, REG_DWORD, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, NoRepair, 1
RegWrite, REG_DWORD, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, NoModify, 1
RegWrite, REG_DWORD, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, EstimatedSize, %Projectsize%
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, UninstallString, "%path%" "-uninst"
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, Publisher, %Author%
RegWrite, REG_SZ, HKEY_LOCAL_MACHINE, SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall\SetupLauncher, FirefoxIntegrated, %firefox_inst%

ToExit:
Run, http://%host%/af/confirmInstall.php?protocol=appurl&version=%Version%
ExitApp
