import {http,httpFile} from "../http_service";

export function createJacket(data) {
    return httpFile().post('/Women/jackets',data);
}
export function loadJackets() {
    return http().get('/Women/jackets');

}
export function deleteJacket(id) {
    return http().delete(`/Women/jackets/${id}`);

}
export function editJacket(id,data){
    return httpFile().post(`/Women/jackets/${id}`,data)
}
export  function loadMoreJackets(nextPage) {
    return http().get(`/Women/jackets?page=${nextPage}`);
}
export function editRating(id,data) {
    return httpFile().post(`/Women/jackets/rating/${id}`,data)
}
