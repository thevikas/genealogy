//@todo test this file!
import {
    SET_USER_PROFILE,
    SET_PERSON,
    ADD_PEOPLE_SUCCESS,
    ADD_PERSON_SUCCESS,
    ADD_PERSON_FAIL,
    ADD_PEOPLE_FAIL,
    APPEND_TO_PEOPLE,
    RESET_CHILDREN,
    APPEND_TO_CHILDREN,
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
    return function(dispatch) {
        dispatch(loadPeople()).then(function() {
            return dispatch(findPerson(id_person))
        })
    }
}

export function findPerson(id_person) {
    return {type: FIND_PERSON, id_person: id_person}
}

export function loadPerson(id_person,dispatch_type = ADD_PERSON_SUCCESS) {
    console.log("calling API to fetch person", id_person);
    return {
        types: [
            'LOAD', dispatch_type, ADD_PERSON_FAIL
        ],
        payload: {
            request: {
                url: APIConfig.api_person_detail(id_person)
            }
        }
    }
}

export function findOrLoadPerson(id_person,dispatch_type = ADD_PERSON_SUCCESS) {
    console.log('trying to find :64', id_person)
    return function(dispatch, getState) {
        console.log('trying to find :67', id_person)

        //find the id in people state
        //if found, return dispatch
        var state = getState()

        const personp = state.people.filter((personp) => personp.person.id_person == id_person)
        if (personp.length > 0)
        {
            console.log("found in thunk, calling setperson", personp[0]);
            return new Promise(function(resolve,reject) {
                dispatch(
                {
                    type: dispatch_type,
                    payload:
                    {
                        data:
                        {
                            person: personp[0].person,
                            father: personp[0].father
                                ? personp[0].father
                                : {},
                            mother: personp[0].mother
                                ? personp[0].mother
                                : {},
                            spouse: personp[0].spouse
                                ? personp[0].spouse
                                : {},
                            child_ids: personp[0].child_ids
                                ? personp[0].child_ids
                                : []
                        }
                    }
                });
                resolve(personp[0]);
            });
        }

        console.log("NOT found in thunk, calling appender");
        return dispatch(loadPerson(id_person,dispatch_type)).then(function()
        {
            console.log("asking to append PERSON");
            var personp;
            if(dispatch_type ==APPEND_TO_CHILDREN)
            {
                var ll = getState().person.children.length;
                personp = dispatch_type == APPEND_TO_CHILDREN ? getState().person.children[ll-1] : getState().person;
            }
            else
                personp = getState().person;

            return dispatch({type: APPEND_TO_PEOPLE, personp: personp});
        })
        //if not found, return another dispatch to fetch that id
        //->find again
    }
}
