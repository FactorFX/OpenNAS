#! /usr/bin/env sh

PAC="bacula cmdwatch ipmitool ncdu nmap ocsinventory-agent pciutils pdksh sssd sysinfo vm-lite zsh"

for P in $PAC; do
	OLD_VERSION=$(make -f $P/Makefile -V DISTVERSION)
	CAT=$(make -f $P/Makefile -V CATEGORIES)
	PORT="/usr/ports/$CAT/$P"
	NEW_VERSION=$(make -f $PORT/Makefile -V DISTVERSION)

	echo "$P $OLD_VERSION -> $NEW_VERSION ($PORT)"
done
