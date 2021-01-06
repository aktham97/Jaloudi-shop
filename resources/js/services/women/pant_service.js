import {http,httpFile} from "../http_service";

export function createPant(data) {
    return httpFile().post('/Women/pants',data);
}
export function loadPants() {
    return http().get('/Women/pants');

}
export function deletePant(id) {
    return http().delete(`/Women/pants/${id}`);

}
export function editPant(id,data){
    return httpFile().post(`/Women/pants/${id}`,data)
}
export  function loadMorePants(nextPage) {
    return http().get(`/Women/pants?page=${nextPage}`);
}
export function editRating(id,data) {
    return httpFile().post(`/Women/pants/rating/${id}`,data)
}
