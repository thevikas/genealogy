
//@todo test this file!
import * as APIConfig from 'APIConfig';
import {
    SET_USER_PROFILE,

    ADD_PEOPLE_SUCCESS,
    ADD_PEOPLE_FAIL,
    FIND_PERSON,

} from 'constants/ActionTypes';

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

export function loadPeopleAndFind(id_person) {
    return function(dispatch){
        dispatch(loadPeople()).then(() => {
            return dispatch(findPerson(id_person))
        })
    }
}

export function findPerson(id_person)
{
    return {type: FIND_PERSON, id_person: id_person}
}
