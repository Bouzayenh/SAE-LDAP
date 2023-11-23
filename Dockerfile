FROM osixia/openldap

ENV LDAP_ORGANISATION="Ldapsae" \LDAP_DOMAIN="ldapsae.com" 

COPY Scripts/bootstrap.ldif /