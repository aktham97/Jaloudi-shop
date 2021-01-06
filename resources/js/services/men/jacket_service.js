import {http,httpFile} from "../http_service";

export function createJacket(data) {
    return httpFile().post('/Men/jackets',data);
}
export function loadJackets() {
    return http().get('/Men/jackets');

}
export function deleteJacket(id) {
    return http().delete(`/Men/jackets/${id}`);

}
export function editJacket(id,data){
    return httpFile().post(`/Men/jackets/${id}`,data)
}
export  function loadMoreJackets(nextPage) {
    return http().get(`/Men/jackets?page=${nextPage}`);
}
export function editRating(id,data) {
    return httpFile().post(`/Men/jackets/rating/${id}`,data)
}
