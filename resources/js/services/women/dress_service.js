import {http,httpFile} from "../http_service";

export function createDress(data) {
    return httpFile().post('/Women/dresses',data);
}
export function loadDresses() {
    return http().get('/Women/dresses');

}
export function deleteDress(id) {
    return http().delete(`/Women/dresses/${id}`);

}
export function editDress(id,data){
    return httpFile().post(`/Women/dresses/${id}`,data)
}
export  function loadMoreDresses(nextPage) {
    return http().get(`/Women/dresses?page=${nextPage}`);
}
export function editRating(id,data) {
    return httpFile().post(`/Women/dresses/rating/${id}`,data)
}
