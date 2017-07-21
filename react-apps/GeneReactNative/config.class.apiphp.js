//import * from 'route.url.maker.js'
export function api_server() {
   return "http://192.168.5.8:8008/api/"
}

//People
export function api_profile() {
    return api_server() + "user"
}
export function api_people_list() {
    return api_server() + "people"
}
export function api_person_detail(id_person) {
    return api_server() + "person/" + id_person
}
export function api_post_new_person() {
    return api_server() + "person"
}
export function api_post_person_edit(id_person) {
    return api_server() + "person/" + id_person
}

/*export const axios_config = {
  headers: {'access-control-allow-origin': '*' }
}
*/
