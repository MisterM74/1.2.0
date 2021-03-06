<?php

/*
 MailWatch for MailScanner
 Copyright (C) 2003-2011  Steve Freegard (steve@freegard.name)
 Copyright (C) 2011  Garrod Alwood (garrod.alwood@lorodoes.com)
 Copyright (C) 2014-2015  MailWatch Team (https://github.com/orgs/mailwatch/teams/team-stable)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 In addition, as a special exception, the copyright holder gives permission to link the code of this program
 with those files in the PEAR library that are licensed under the PHP License (or with modified versions of those
 files that use the same license as those files), and distribute linked combinations including the two.
 You must obey the GNU General Public License in all respects for all of the code used other than those files in the
 PEAR library that are licensed under the PHP License. If you modify this program, you may extend this exception to
 your version of the program, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your version.

 As a special exception, you have permission to link this program with the JpGraph library and
 distribute executables, as long as you follow the requirements of the GNU GPL in regard to all of the software
 in the executable aside from JpGraph.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Include of necessary functions
require_once("./functions.php");

// Authentication checking
session_start();
require('login.function.php');

html_start('Tools', "0", false, false);

echo '<table width="100%" class="boxtable">
 <tr>
  <td>
   <p>Tools</p>
   <ul>';

echo '<li><a href="user_manager.php">User Management</a>';

if (preg_match('/sophos/i', get_conf_var('VirusScanners')) && $_SESSION['user_type'] == 'A') {
    echo '<li><a href="sophos_status.php">Sophos Status</a>';
}
if (preg_match('/f-secure/i', get_conf_var('VirusScanners')) && $_SESSION['user_type'] == 'A') {
    echo '<li><a href="f-secure_status.php">F-Secure Status</a>';
}
if (preg_match('/clam/i', get_conf_var('VirusScanners')) && $_SESSION['user_type'] == 'A') {
    echo '<li><a href="clamav_status.php">ClamAV Status</a>';
}
if (preg_match('/mcafee/i', get_conf_var('VirusScanners')) && $_SESSION['user_type'] == 'A') {
    echo '<li><a href="mcafee_status.php">McAfee Status</a>';
}
if (preg_match('/f-prot/i', get_conf_var('VirusScanners')) && $_SESSION['user_type'] == 'A') {
    echo '<li><a href="f-prot_status.php">F-Prot Status</a>';
}
if ($_SESSION['user_type'] == 'A') {
    echo '<li><a href="mysql_status.php">MySQL Database Status</a>';
    echo '<li><a href="msconfig.php">View MailScanner Configuration</a>';
	if (defined('MSRE') && MSRE) { 
      echo '<li><a href="msre_index.php">Edit MailScanner Rulesets</a>';
	}
}
if (!DISTRIBUTED_SETUP
    && !in_array(strtolower(get_conf_var('UseSpamAssassin')), array('0', 'no', false))
    && $_SESSION['user_type'] == 'A'
) {
    echo '
     <li><a href="bayes_info.php">SpamAssassin Bayes Database Info</a>
     <li><a href="sa_lint.php">SpamAssassin Lint (Test)</a>
     <li><a href="ms_lint.php">MailScanner Lint (Test)</a>
     <li><a href="sa_rules_update.php">Update SpamAssassin Rule Descriptions</a>';
}
if (!DISTRIBUTED_SETUP && get_conf_truefalse('MCPChecks') && $_SESSION['user_type'] == 'A') {
    echo '<li><a href="mcp_rules_update.php">Update MCP Rule Descriptions</a>';
}
if ($_SESSION['user_type'] == 'A') {
    echo '<li><a href="geoip_update.php">Update GeoIP Database</a>';
}
echo '</ul>';
if ($_SESSION['user_type'] == 'A') {
    echo '
   <p>Links</p>
   <ul>
    <li><a href="http://mailwatch.sourceforge.net">MailWatch for MailScanner</a>
    <li><a href="http://www.mailscanner.info">MailScanner</a>';

    if (get_conf_truefalse('UseSpamAssassin')) {
        echo '<li><a href="http://www.spamassassin.org">SpamAssassin</a>';
    }

    if (preg_match('/sophos/i', get_conf_var('VirusScanners'))) {
        echo '<li><a href="http://www.sophos.com">Sophos</a>';
    }

    if (preg_match('/clam/i', get_conf_var('VirusScanners'))) {
        echo '<li><a href="http://clamav.sourceforge.net">ClamAV</A>';
    }

    echo '
    <li><a href="http://www.dnsstuff.com">DNSstuff</a>
    <li><a href="http://mxtoolbox.com/NetworkTools.aspx">MXToolbox Network Tools</a>
    <li><a href="http://www.anti-abuse.org/multi-rbl-check/">Multi-RBL Check</a>
   </ul>';
}

echo '
   </td>
 </tr>
</table>';

// Add footer
html_end();
// Close any open db connections
dbclose();
