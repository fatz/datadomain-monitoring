collectd configuration
======================

To measure datadomain metrics you can use the collectd [snmp plugin](https://collectd.org/wiki/index.php/Plugin:SNMP) this `collectd.cfg` and the `my_types` shows a few examples you can use to measure your datadomain.

The `dd_systat` definition collects some important performance metrics like disk- and cpu busy as well as the replication or disk throughput.

`dd_space` measures the raw disk usage.

`dd_replication` measures the bytes left or bytes send of all replication contexts