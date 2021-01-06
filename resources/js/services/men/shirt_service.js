import {http,httpFile} from "../http_service";

export function createShirt(data) {
    return httpFile().post('/Men/shirts',data);
}
export function loadShirts() {
    return http().get('/Men/shirts');

}
export function deleteShirt(id) {
    return http().delete(`/Men/shirts/${id}`);

}
export function editShirt(id,data){
    return httpFile().post(`/Men/shirts/${id}`,data)
}
export  function loadMoreShirts(nextPage) {
    return http().get(`/Men/shirts?page=${nextPage}`);
}
export function editRating(id,data) {
    return httpFile().post(`/Men/shirts/rating/${id}`,data)
}
