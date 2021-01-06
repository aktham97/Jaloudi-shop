import {http,httpFile} from "../http_service";

export function createPant(data) {
    return httpFile().post('/Men/pants',data);
}
export function loadPants() {
    return http().get('/Men/pants');

}
export function deletePant(id) {
    return http().delete(`/Men/pants/${id}`);

}
export function editPant(id,data){
    return httpFile().post(`/Men/pants/${id}`,data)
}
export  function loadMorePants(nextPage) {
    return http().get(`/Men/pants?page=${nextPage}`);
}
export function editRating(id,data) {
    return httpFile().post(`/Men/pants/rating/${id}`,data)
}
