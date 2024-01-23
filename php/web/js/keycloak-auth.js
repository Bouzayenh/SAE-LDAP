import express from 'express';

const keycloak = new Keycloak({
    url: 'http://localhost:8082/',
    realm: 'sae-services',
    clientId: 'php-service'
})

async function initKeyCloak(){
    return await keycloak.init(initOptions);
}
    const initOptions = {
        onLoad: 'login-required',
    };
    function logout(){
        Cookies.remove('token');
        Cookies.remove('callback');
        keycloak.logout();
    }
    let authenticated = false;
    
    try{
        authenticated = initKeyCloak();
        console.log('Init Response : ' + (authenticated ? 'Authenticated' : 'Not Authenticated'));
        console.log(authenticated);
        Cookies.set('token', keycloak.token);
        
        console.log("Test : " + JSON.stringify(keycloak.token) + "Authenticated ? " + keycloak.authenticated);
    }
    catch (error) {
        console.log('Error : ' + error);
    };

    console.log("Keycloak token : " + JSON.stringify(keycloak));
    
    
    const app = express();

    app.use(keycloak.middleware( { logout: '/logoff' }));
