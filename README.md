Web-based LAN Seeker
====================

Software installation over LAN-connection via a light weight web interface.

This interface was created for user-friendly software distribution in a local network. Previous versions consisted of
executables on each client machine with hard coded network paths the software setups. When the host (distributing
machine) changed, all executables on all client machines had to be updated. This iteration of the **LAN Seeker** is
web-based and does not require software on the client machines<sup>[1](#footnoteClientSoftware)</sup>. It may be freely
modified and updated without requiring software upgrades on the client machines.

**Note:** This software was built with the installation of games in mind. That is why classes are named and documented
accordingly. Nevertheless, it is not limited to games but can be used with any kind of software.

**Note:** Although, this framework may be hosted on a computer running any kind of operating system. the client machines
are assumed to be running windows.

Preview
-------

*Click for animated preview*

[![Click for animated preview](http://i.imgur.com/7x7mcOC.jpg)](http://i.imgur.com/j5pM8RE.gif)

**Note:** The front-end UI language is German. All code documentation and log entries are in English, however. Changing
the UI language should be not too much effort, since there is not much text output in the front-end. There is no
dedicated language file.

Installation
------------

This software neither supplies a dedicated back-end nor is an automatic database configuration included. Software like
`phpMyAdmin` should suffice as back-end. To run this software, set up an SQL database of the following structure.
Additionally the [config.php](af/inc/config.php) needs to be adjusted with database connection details.

```
Database
 |
 +-- distributors               Network machines from which the software may be installed
 |    |
 |    +-- id           int        ID
 |    +-- name         varchar    Description of distributor PC
 |    +-- drive        varchar    Network name of PC (e.g. \\PC-ONE\)
 |    +-- path         varchar    Path where the software is found
 |    +-- utilization  float      Preference order (higher numbers are preferred, zero is ignored)
 |
 +-- games                      Table of software that is available
 |    |
 |    +-- id           int        ID
 |    +-- name         varchar    Display name of the software
 |    +-- cover        varchar    Cover image (png-file of the dimensions 93x302 pixels)
 |    +-- exe          varchar    Executable on the distributor machine (should be the setup)
 |    +-- order        decimal    Ordering: sorted left-to-right display position, small-to-large numbers
 |
 +-- profiles                   Different lists of download options
 |    |
 |    +-- id           int        ID
 |    +-- name         varchar    Descriptor (only visible in back-end)
 |    +-- games        varchar    IDs of the games-table separated with commas (specify all for all)
 |    +-- active       tinyint    Boolean, whether active or not
 |
 +-- protocols                  The web-protocol which is used to start an executable from the browser
 |    |
 |    +-- protocol     varchar    Browser appurl, initialize to: appurl
 |    +-- versionlist  varchar    List of available versions, initialize to: |7.0.0.1|7.0.0.2|7.0.0.3|
 |
 +-- protocal_appurl            Log of web-protocols installed on client machines. Related to appurl
      |
      +-- client       varchar    Lower case network name
      +-- version      varchar    Installed version of appurl

```

Here is SQL code to create the necessary table structure (along with some data).

``` SQL
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE IF NOT EXISTS `distributors` (`id` int(11) NOT NULL, `name` varchar(64) NOT NULL, `drive` varchar(32) NOT NULL, `path` varchar(1248) NOT NULL, `utilization` float NOT NULL) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `games` (`id` int(10) unsigned NOT NULL, `name` varchar(64) NOT NULL, `cover` varchar(64) NOT NULL, `exe` varchar(64) NOT NULL, `order` decimal(10,0) unsigned NOT NULL) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `profiles` (`id` int(10) unsigned NOT NULL, `name` varchar(64) NOT NULL, `games` varchar(265) NOT NULL, `active` tinyint(1) NOT NULL DEFAULT '0') ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `protocols` (`protocol` varchar(32) NOT NULL, `versionlist` varchar(128) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `protocols` (`protocol`, `versionlist`) VALUES ('appurl', '|7.0.0.1|7.0.0.2|7.0.0.3|');
CREATE TABLE IF NOT EXISTS `protocol_appurl` (`client` varchar(64) NOT NULL, `version` varchar(32) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `distributors` ADD PRIMARY KEY (`id`);
ALTER TABLE `games` ADD PRIMARY KEY (`id`);
ALTER TABLE `profiles` ADD PRIMARY KEY (`id`);
ALTER TABLE `protocols` ADD UNIQUE KEY `protocol` (`protocol`);
ALTER TABLE `protocol_appurl` ADD UNIQUE KEY `client` (`client`);
ALTER TABLE `distributors` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `games` MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `profiles` MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
```

AppURL
------

In order to launch executables from the web-interface, a **URL protocol** is necessary.
> "You can type appurl://path/to/myapp.exe in the address bar of your browser to launch the application"

Installing the **LAN Seeker**-specific URL protocol is done easily from the web-interface with a dedicated setup. This
setup is writing to windows registry and adds browser specific rules. The dedicated setup is marked with a version
number and its installation is logged for each client. This way the web-interface will inform the client of a new
version and will prompt for install.

The setup is written in [AutoHotkey](http://autohotkey.com) and the host-name should be adjusted in
[`appurl_inst.ahk`](af/dev/appurl_inst.ahk).

```AutoHotkey
      ...
  16  Progress, 10
  17
> 18  host := "PC-HOST" ; Enter host here: Network-name of the machine running the web-interface
  19  Author := "szapp"
  20  Version = 7.0.0.3
      ...
```

**Warning** `Installing an URL protocol introduces high security risks. Use with caution!`

**Build**

After adjusting the host-name as indicated above, [`appurl_inst.ahk`](af/dev/appurl_inst.ahk) needs to be compiled. The
compiled [`appurl.exe`](af/exec) must be in the same directory as [`appurl_inst.ahk`](af/dev/appurl_inst.ahk) for the
compiler to find and pack it into the resulting setup.

When altering the code in [`appurl.ahk`](af/dev/appurl.ahk), both [`appurl.ahk`](af/dev/appurl.ahk) **and**
[`appurl_inst.ahk`](af/dev/appurl_inst.ahk) need to be re-compiled.

Further information
-------------------

The initial goal of the LAN Seeker was to offer a stand-alone tool aiming to be as lightweight as possible.
With increasing demand of complex features, it grew into a more rigid framework and eventually ran into implementation
constraints.
While the previous `LAN Seeker` and `Game Installer` were two distinct tools mostly working individually from different
machines, the **LAN Seeker** now combines and centralizes them into one web interfaces. By keeping the code and
distribution on one machine, the tool stays flexible and up-to-date without any client downloads or compatibility
issues. With access to one network node only, the distribution of software can be administrated more efficiently.
A web-based interface is even more lightweight than the initial version, though adding a lot more features. The greatest
of which is its flexibility.

Acknowledgements
----------------

Used scripts

jQuery
- **[jQuery v1.10.2](http://jquery.com/)** authored by *[jQuery Foundation, Inc.](https://jquery.org/)*
- **[jScrollPane](http://jscrollpane.kelvinluck.com/)** authored by *[Kelvin Luck](http://www.kelvinluck.com/)*
- **[Mouse Wheel Data Collector](https://github.com/brandonaaron/mousewheel-data-collector)** authored by
*[Brandon Aaron](http://brandon.aaron.sh)*

AutoHotkey
- **[Application URL](http://www.autohotkey.com/forum/viewtopic.php?t=76997)** authored by *Jeff "jsherk" Sherk*

-------------

<a name="footnoteClientSoftware">1</a>: Actually there software is installed on the client machine (appurl protocol for
starting executables from browser). However, it can be easily maintained and updated through the web-interface.
