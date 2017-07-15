//@todo test this file!
import {
    SET_USER_PROFILE,

    ADD_PEOPLE_SUCCESS,
    ADD_PEOPLE_FAIL,
    FIND_PERSON,
    SET_VIEWINFO
} from 'constants/ActionTypes';

import * as APIConfig from 'APIConfig';

export function setViewinfo(viewinfo) {
    return {type: SET_VIEWINFO, viewinfo};
}

export function setUser(user) {
    return {type: SET_USER_PROFILE, user};
}

export function loadPeople() {
    return {
        types: [
            'LOAD', ADD_PEOPLE_SUCCESS, ADD_PEOPLE_FAIL
        ],
        payload: {
            request: {
                url: APIConfig.api_people_list()
            }
        }
    }
}

export function loadPeopleAndFindPerson(id_person) {
    return function(dispatch){
        dispatch(loadPeople()).then(function(){
            return dispatch(findPerson(id_person))
        })
    }
}


export function findPerson(id_person)
{
    return {type: FIND_PERSON, id_person: id_person}
}
