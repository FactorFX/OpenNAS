#! /usr/bin/env sh

PAC="bacula5-server cmdwatch curl ipmitool ncdu nload nmap ocsinventory-agent openldap24-client pciutils pdksh perl5.16 python27 sssd sudo sysinfo usbutils vim-lite wget zfs-stats zsh"

for P in $PAC; do
	OLD_VERSION=$(make -f $P/Makefile -V DISTVERSION)
	CAT=$(make -f $P/Makefile -V CATEGORIES | awk 'FS=" " {print $1}')
	PORT="/usr/ports/$CAT/$P"
	NEW_VERSION=$(make -f $PORT/Makefile -V DISTVERSION)

	echo "$P $OLD_VERSION -> $NEW_VERSION ($PORT)"
done
