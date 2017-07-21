import {
    SET_USER_PROFILE,
    ADD_PEOPLE,
    ADD_PEOPLE_SUCCESS,
    APPEND_TO_PEOPLE
} from 'ActionTypes';

import  * as Helpers from 'helperfunctions'

export default function person(state = [], action) {
    switch (action.type) {
        case ADD_PEOPLE_SUCCESS:
            return action.payload.data;
        case APPEND_TO_PEOPLE:
            if(state && state.length>0)
            {
                console.log("concat to people",action,state);
                return state.concat(action.personp);
            }
            else {
                console.log("append to new people array",action);
                var newobj = {person:{},father:{},mother:{},spouse:{}};
                Helpers.copyPersonObject(newobj.person,action.personp.person);
                Helpers.copyPersonObject(newobj.father,action.personp.father);
                Helpers.copyPersonObject(newobj.mother,action.personp.mother);
                Helpers.copyPersonObject(newobj.spouse,action.personp.spouse);

                if(action.personp.child_ids.length>0)
                {
                    newobj.child_ids = [];
                    for(var i=0;i<action.personp.child_ids.length; i++)
                        newobj.child_ids.push(action.personp.child_ids[i]);
                }

                return [newobj];
            }
        default:
            return state;
    }
}
