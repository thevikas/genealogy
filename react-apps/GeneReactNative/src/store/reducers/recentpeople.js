import * as types from 'constants/ActionTypes';

import  * as Helpers from 'helperfunctions'

export default function recentpeople(state = [], action) {
    switch (action.type) {
        case types.APPEND_TO_RPEOPLE:
            if(state && state.length>0)
            {
                console.log("concat to rpeople",action,state);

                const person = state.filter((person) => person.id_person == action.person.id_person)
                if (person.length == 0)
                    return state.concat(action.person);
                //if found, return same state untouched
                return state;
            }
            else {
                console.log("append to new rpeople array",action);
                var newobj = {};
                Helpers.copyPersonObject(newobj,action.person);

                return [newobj];
            }
        default:
            return state;
    }
}
