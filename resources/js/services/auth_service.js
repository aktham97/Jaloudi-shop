import {http,httpFile} from "./http_service";
import jwt from 'jsonwebtoken';

export function register(user) {
    return http().post('/auth/register',user);

}
export function login(user) {
    return http().post('/auth/login',user)
        .then(response =>{
            if (response.status === 200)
            {
                setToken(response.data)
            }
            return response.data;
        })

}
function setToken(user) {
    var token = jwt.sign({ user: user }, 'shopusertokenfeerere');
    localStorage.setItem('shop-user-token',token)
}
export function isLoggedIN() {
    const token = localStorage.getItem('shop-user-token');
    return token != null;
    
}
export function logout() {

     http().get('/auth/logout');
    localStorage.removeItem('shop-user-token');
}
export function getAccessToken() {
    const token = localStorage.getItem('shop-user-token');
    if (!token)
    {
        return null;
    }
        const tokenData = jwt.decode(token);
        return tokenData.user.access_token;

}
