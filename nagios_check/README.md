# NAME

check\_datadomain - Checks Datadomain states via snmp

# DESCRIPTION

This plugins monitors some states of your datadomain via snmp. It can monitor for example the state of the PSUs, NVRAM, disks and so on.
 

# VERSION

Version 0.1r1

# SYNOPSIS

check\_datadomain -H <hostname> \[-C <COMMUNITY>\] \[-p <port>\] \[-P <snmp-version>\] -m <method> ( FSSPACE \[-w <warning % USED>\] \[-c <critical % USED>\] | IFSTATE -i <interface id>)

# OPTIONS

- \-H <hostname> (required)

    Define the hostname

- \-C <community> (optional)

    Optional community string for SNMP communication (default: public)

- \-p, --port <portnumber>

    Port number (default: 161)

- \-P, --protocol <protocol>

    SNMP protocol version \[1,2c\]

- \-m, --method <checkmethod>

    check method one of PSU, NVRAM, FAN, DISKSTATE, FSSPACE, IFSTATE

    - PSU: State of all Powersupplies
    - NVRAM: NVRAM battery state
    - FAN: Fan state of all enclosures
    - DISKSTATE: disk states
    - FSSPACE: used filesystem space. -w for waring % -c for critical %
        - Defaults: -w 75 -c 90
    - IFSTATE: Checks if the given interfaces are up. e.g.:-i 2,3
        - do a snmpwalk on IF-MIB to get the interface ids

- \-i, --iface <if ids>

    comma seperated list of interface ids that should be up (use snmpwalk to get them)

- \-w, --warning <number>

    warning filesystem space usage in %

- \-c, --critical <number>

    critical filesystem space usage in %

- \-h, --help

    Print detailed help screen. You also can use perldoc check\_datadomain 

- \-V, --version

    Print version information

# AUTHOR

Jan Ulferts <jan.ulferts@xing.com>

# KNOWN ISSUES

currently not

# BUGS

of course not

# REQUIRES

- Perl 5
- Getopt::Long
- Net::SNMP

# LICENSE

The MIT License (MIT)

Copyright (c) 2013 Jan Ulferts

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

# HISTORY

23. 01.2013: Version 0.1
20. 11.2013: Version 0.1r1 Added some documentation for publishing
