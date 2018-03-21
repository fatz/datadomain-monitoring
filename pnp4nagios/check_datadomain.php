<?php
#
# Copyright (c) 2018 Christophe Drevet-Droguet <dr4ke@dr4ke.net>
# Plugin: check_datadomain.pl (REPLICATION method)
#

$count=0;
foreach ($DS as $i) {
    $count++;
    if (preg_match('/_precompsent$/',$NAME[$i])) {
        $NAME[$i] = "Pre-compression traffic";
        $opt[$count] = " --vertical-label \"Bytes/s\" --title \"Pre-compression Sent for $hostname / $servicedesc\" ";
        $def[$count] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$count] .= rrd::gradient("var1", "ffaaaa", "ff3333", "traffic") ;
        $def[$count] .= "GPRINT:var1:LAST:\"%7.2lf %SB/s last\" " ;
        $def[$count] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB/s avg\" " ;
        $def[$count] .= "GPRINT:var1:MAX:\"%7.2lf %SB/s max\\n\" " ;
    } elseif (preg_match('/_postcompsent$/',$NAME[$i])) {
        $NAME[$i] = "Post-compression traffic";
        $opt[$count] = " --vertical-label \"Bytes/s\" --title \"Post-compression Sent for $hostname / $servicedesc\" ";
        $def[$count] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$count] .= rrd::gradient("var1", "ffaaaa", "ff3333", "traffic") ;
        $def[$count] .= "GPRINT:var1:LAST:\"%7.2lf %SB/s last\" " ;
        $def[$count] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB/s avg\" " ;
        $def[$count] .= "GPRINT:var1:MAX:\"%7.2lf %SB/s max\\n\" " ;
    } elseif (preg_match('/_postcomprcv$/',$NAME[$i])) {
        $NAME[$i] = "Post-compression traffic";
        $opt[$count] = " --vertical-label \"Bytes/s\" --title \"Post-compression Received for $hostname / $servicedesc\" ";
        $def[$count] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$count] .= rrd::gradient("var1", "aaaaff", "3333ff", "traffic") ;
        $def[$count] .= "GPRINT:var1:LAST:\"%7.2lf %SB/s last\" " ;
        $def[$count] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB/s avg\" " ;
        $def[$count] .= "GPRINT:var1:MAX:\"%7.2lf %SB/s max\\n\" " ;
    } elseif (preg_match('/_precompremain$/',$NAME[$i])) {
        $NAME[$i] = "Pre-compression remaining";
        $opt[$count] = " --vertical-label \"Bytes\" -l 0 -b 1024 --title \"Pre-compression remaining for $hostname / $servicedesc\" ";
        $def[$count] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$count] .= rrd::gradient("var1", "aa88ff", "aa00ff", "remaining") ;
        $def[$count] .= "GPRINT:var1:LAST:\"%7.2lf %SB last\" " ;
        $def[$count] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB avg\" " ;
        $def[$count] .= "GPRINT:var1:MAX:\"%7.2lf %SB max\\n\" " ;
    } elseif (preg_match('/_lastsynced$/',$NAME[$i])) {
        $NAME[$i] = "Last synced time (days ago)";
        $opt[$count] = " --vertical-label \"hours ago\" --title \"Last synced time for $hostname / $servicedesc\" ";
        $def[$count] = "DEF:ds1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$count] .= "CDEF:var1=ds1,3600,/ " ;
        $def[$count] .= rrd::gradient("var1", "88ff88", "00aa00", "last synced") ;
        $def[$count] .= "GPRINT:var1:LAST:\"%7.2lf hours last\" " ;
        $def[$count] .= "GPRINT:var1:AVERAGE:\"%7.2lf hours avg\" " ;
        $def[$count] .= "GPRINT:var1:MAX:\"%7.2lf hours max\\n\" " ;
    }
}
?>
