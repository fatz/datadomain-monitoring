<?php
#
# Copyright (c) 2018 Christophe Drevet-Droguet <dr4ke@dr4ke.net>
# Plugin: check_datadomain.pl
#

foreach ($DS as $i) {
    if (preg_match('/_precompsent$/',$NAME[$i])) {
        $ds_name[$i]  = "Pre-compression Sent for ";
        $label = substr($LABEL[$i], 0, strlen($LABEL[$i]) - 12);
        $title = $ds_name[$i].preg_replace(',^.*/([^/]*)$,', '$1', $label);
        $ds_name[$i] .= $label;
        $opt[$i] = " --vertical-label \"Bytes/s\" --title \"".$title."\" ";
        $def[$i] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= rrd::gradient("var1", "ff3333", "ffaaaa", "traffic") ;
        $def[$i] .= rrd::line1("var1", "#880000") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf %SB/s last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB/s avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf %SB/s max\\n\" " ;
    } elseif (preg_match('/_postcompsent$/',$NAME[$i])) {
        $ds_name[$i]  = "Post-compression Sent for ";
        $label = substr($LABEL[$i], 0, strlen($LABEL[$i]) - 13);
        $title = $ds_name[$i].preg_replace(',^.*/([^/]*)$,', '$1', $label);
        $ds_name[$i] .= $label;
        $opt[$i] = " --vertical-label \"Bytes/s\" --title \"".$title."\" ";
        $def[$i] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= rrd::gradient("var1", "ff3333", "ffaaaa", "traffic") ;
        $def[$i] .= rrd::line1("var1", "#880000") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf %SB/s last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB/s avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf %SB/s max\\n\" " ;
    } elseif (preg_match('/_postcomprcv$/',$NAME[$i])) {
        $ds_name[$i]  = "Post-compression Received for ";
        $label = substr($LABEL[$i], 0, strlen($LABEL[$i]) - 12);
        $title = $ds_name[$i].preg_replace(',^.*/([^/]*)$,', '$1', $label);
        $ds_name[$i] .= $label;
        $opt[$i] = " --vertical-label \"Bytes/s\" --title \"".$title."\" ";
        $def[$i] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= rrd::gradient("var1", "3333ff", "aaaaff", "traffic") ;
        $def[$i] .= rrd::line1("var1", "#000088") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf %SB/s last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB/s avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf %SB/s max\\n\" " ;
    } elseif (preg_match('/_precompremain$/',$NAME[$i])) {
        $ds_name[$i]  = "Pre-compression remaining for ";
        $label = substr($LABEL[$i], 0, strlen($LABEL[$i]) - 14);
        $title = $ds_name[$i].preg_replace(',^.*/([^/]*)$,', '$1', $label);
        $ds_name[$i] .= $label;
        $opt[$i] = " --vertical-label \"Bytes\" -l 0 -b 1024 --title \"".$title."\" ";
        $def[$i] = "DEF:var1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= rrd::gradient("var1", "aa00ff", "aa88ff", "remaining") ;
        $def[$i] .= rrd::line1("var1", "#330088") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf %SB last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf %SB max\\n\" " ;
    } elseif (preg_match('/_lastsynced$/',$NAME[$i])) {
        $ds_name[$i]  = "Last synced time for ";
        $label = substr($LABEL[$i], 0, strlen($LABEL[$i]) - 11);
        $title = $ds_name[$i].preg_replace(',^.*/([^/]*)$,', '$1', $label);
        $ds_name[$i] .= $label;
        $opt[$i] = " --vertical-label \"hours ago\" --title \"".$title."\" ";
        $def[$i] = "DEF:ds1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= "CDEF:var1=ds1,3600,/ " ;
        $def[$i] .= rrd::gradient("var1", "00aa00", "88ff88", "last synced") ;
        $def[$i] .= rrd::line1("var1", "#008800") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf hours last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf hours avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf hours max\\n\" " ;
        # create warning line and legend
        if ($WARN[$i] != "") {
                $warn = $WARN[$i] / 3600;
                $def[$i] .= rrd::hrule( $warn, "#ffff00", "Warning  $warn hours\\n" );
        }
        # create critical line and legend
        if ($CRIT[$i] != "") {
                $crit = $CRIT[$i] / 3600;
                $def[$i] .= rrd::hrule( $crit, "#ff0000", "Critical $crit hours\\n" );
        }
    } elseif (preg_match('/_perc$/',$NAME[$i])) {
        $ds_name[$i]  = "FS space usage for $hostname / ";
        $ds_name[$i] .= substr($NAME[$i],0,strlen($NAME[$i]) - 5);
        $opt[$i] = " --vertical-label \"percent\" --title \"".$ds_name[$i]."\" ";
        $opt[$i] .= " -l 0 -u 100 ";
        $def[$i] = "DEF:ds1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= "CDEF:var1=ds1 " ;
        $def[$i] .= rrd::gradient("var1", "#33aa33", "#88ff88", "FS usage") ;
        $def[$i] .= rrd::line1("var1", "#008800") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf %% last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf %% avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf %% max\\n\" " ;
        # create warning line and legend
        if ($WARN[$i] != "") {
                $warn = $WARN[$i];
                $def[$i] .= rrd::hrule( $warn, "#ffff00", "Warning  $warn %\\n" );
        }
        # create critical line and legend
        if ($CRIT[$i] != "") {
                $crit = $CRIT[$i];
                $def[$i] .= rrd::hrule( $crit, "#ff0000", "Critical $crit %\\n" );
        }
    } elseif (preg_match('/_avail$/',$NAME[$i])) {
        $ds_name[$i]  = "Free space for ";
        $ds_name[$i] .= substr($LABEL[$i],0,strlen($LABEL[$i]) - 6);
        $opt[$i] = " --vertical-label \"bytes\" --title \"".$ds_name[$i]."\" ";
        $def[$i] = "DEF:ds1=$RRDFILE[1]:$DS[$i]:AVERAGE " ;
        $def[$i] .= "CDEF:var1=ds1,1024,1024,1024,*,*,* " ;
        $def[$i] .= rrd::gradient("var1", "#b6b6b6", "#d6d6d6", "Free space") ;
        $def[$i] .= rrd::line1("var1", "#003300") ;
        $def[$i] .= "GPRINT:var1:LAST:\"%7.2lf %SB last\" " ;
        $def[$i] .= "GPRINT:var1:AVERAGE:\"%7.2lf %SB avg\" " ;
        $def[$i] .= "GPRINT:var1:MAX:\"%7.2lf %SB max\\n\" " ;
    } else {
        $opt[$i] = "";
        $def[$i] = "";
    }
}
?>
