# $FreeBSD: head/net-mgmt/ocsinventory-agent/Makefile 366151 2014-08-25 20:58:30Z marino $

PORTNAME=		Ocsinventory
PORTVERSION=	2.1.1

COMMENT=	 Keep track of the computers configuration and software

MASTERDIR=	/usr/ports/net-mgmt/ocsinventory-agent

BUILD_DEPENDS+=${RUN_DEPENDS}

PATCHDIR+=${.CURDIR}/files

STAGEDIR=	${NAS4FREE_ROOTFS}

BIN_DEP=GET HEAD POST lwp-download lwp-dump lwp-mirror lwp-request \
	iptab \
	snmpkey \
	xml_grep xml_merge xml_pp xml_spellcheck xml_split \
	xpath

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/etc/ocsinventory/
	${CP} ${.CURDIR}/files/modules.conf ${NAS4FREE_ROOTFS}/usr/local/etc/ocsinventory/
	
	#Copy dependencies
		
	for BIN in ${BIN_DEP}; do
		${CP} /usr/local/bin/$$BIN ${NAS4FREE_ROOTFS}/usr/local/bin
	done

	for DIR in snmp w3m; \
		do (${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/share/$$DIR/; \
			${CP} -R /usr/local/share/$$DIR/ ${NAS4FREE_ROOTFS}/usr/local/share/$$DIR/); \
	done
	
	# Install service script
	${INSTALL_SCRIPT} -v ${.CURDIR}/files/ocsinventory_agent.in ${NAS4FREE_ROOTFS}/etc/rc.d/ocsinventory_agent
	
.include "${MASTERDIR}/Makefile"
