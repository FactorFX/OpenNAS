alias reboot='shutdown -r now'
alias menu='/etc/rc.initial display_menu'

# Display console banner (only on ttyv0/ttyd0).
if ( "ttyv0" == "$tty" || "ttyu0" == "$tty" ) then
	/etc/rc.banner
	/etc/rc.initial
endif