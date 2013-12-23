;mpress
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

; TODO: Install appurl.exe

SetRegView 32 ; Wow6432Node\
RegRead, tmp, HKEY_CLASSES_ROOT, appurl
if (tmp = "URL:appurl protocol")
{
	; Already installed
	; MsgBox, Already installed ; Remove
	GoSub, ToExit
}

; TODO: Adjust path
path := "D:\Data\Dropbox\Projects\AutoHotkey Scripts\AppURL\appurl.exe"

subkeys := [], keys := [], values := []
subkeys.Insert("appurl")
   keys.Insert(""), values.Insert("URL:appurl protocol")
subkeys.Insert("appurl")
   keys.Insert(""), values.Insert("")
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
	                 NC:prettyName="appurl.exe"
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
	; %A_LoopFileLongPath%\mimeTypes.rdf
	FileCopy, %A_LoopFileLongPath%\mimeTypes.rdf, %A_LoopFileLongPath%\mimeTypes.rdf.BAK, 1
	FileRead, Contents, %A_LoopFileLongPath%\mimeTypes.rdf
	if ErrorLevel
		Continue
	StringReplace, Contents, Contents, <RDF:Seq RDF:about="urn:schemes:root">, <RDF:Seq RDF:about="urn:schemes:root">`n    <RDF:li RDF:resource="urn:scheme:appurl"/>
	StringReplace, Contents, Contents, </RDF:RDF>, %addto%
	FileDelete, %A_LoopFileLongPath%\mimeTypes.rdf
	FileAppend, %Contents%, %A_LoopFileLongPath%\mimeTypes.rdf
}

ToExit:
Run, http://PC-HOST/lanseeker/af/confirmInstall.php?protocol=appurl
ExitApp
