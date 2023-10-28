FROM osixia/openldap:1.5.0

ENV LDAP_ORGANISATION="Mon Organisation" \
    LDAP_DOMAIN="mondomaine.com" \
    LDAP_ADMIN_PASSWORD="admin"

# Autres configurations
