#! /usr/bin/env sh

export NAS4FREE_ROOTFS="defined"

PAC="bacula5-server cmdwatch ipmitool \
	ncdu nload nmap ocsinventory-agent openldap24-client \
	pciutils pdksh rsnapshot sssd sysinfo \
	usbutils vim-lite wget zfs-stats zsh"

for P in $PAC; do
	CAT=$(make -f $P/Makefile -V CATEGORIES | awk 'FS=" " {print $1}')
	PORT="/usr/ports/$CAT/$P"
	
	OLD_VERSION=$(make -f $P/Makefile -V DISTVERSION)
	NEW_VERSION=$(make -f $PORT/Makefile -V DISTVERSION .CURDIR="$PORT")
	
	PERL_VER=$(make -f $P/Makefile -V PERL_VER)
	STAGEDIR=$(make -f $P/Makefile -V STAGEDIR)
	MANDIRS=$(make -f $P/Makefile -V MANDIRS)

	echo "****************** $P **************************"
	echo "VERSION $OLD_VERSION -> $NEW_VERSION ($PORT)"
	echo "PERL: $PERL_VER"
	echo "STAGEDIR :$STAGEDIR"
	echo "MANDIRS :$MANDIRS"
done
