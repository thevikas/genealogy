import {StyleSheet} from 'react-native';

export const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection: 'column',
        justifyContent: 'space-between'
    },
    mydata: {
        flexDirection: 'column',
        justifyContent: 'flex-start',
        alignItems: 'flex-start',
        minHeight: "    25%",
        maxHeight: "25%"
    },
    mychildren: {
        flexDirection: 'column',
        justifyContent: 'flex-start',
    },
    recent: {
        borderTopWidth: 2,
        borderColor: "blue",
        flexDirection: 'column',
        justifyContent: 'flex-start',
        minHeight: "25%",
        maxHeight: "25%"
    },
    myrow: {
        flexDirection: 'row'
    },
    label: {
        padding: 10,
        fontSize: 18,
        height: 44,
        width: "30%"
    },
    childrow: {},
    childrenheader: {
        padding: 10,
        fontSize: 22,
        fontWeight: 'bold'
    },
    item: {
        padding: 10,
        fontSize: 18,
        fontWeight: 'bold'
    }
})
