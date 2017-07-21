import * as types from 'constants/ActionTypes';
import  * as Helpers from 'helperfunctions'

export default function person(state = [], action) {
    switch (action.type) {
        case types.ADD_PEOPLE_SUCCESS:
            return action.payload.data;
        case types.RESET_CHILDREN:
            return [];
        case types.APPEND_TO_CHILDREN:
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
                return [newobj];
            }
        default:
            return state;
    }
}
