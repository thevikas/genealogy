import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import moment from 'moment';

import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';
import * as PActions from 'store/actions';
import PropTypes from 'prop-types';

export class Breadcrumb extends Component {
    render() {
        return (
            <div id="content-header">
                <div id="breadcrumb">
                    <Link to="/" class="tip-bottom" data-original-title="Go to Home">
                        <i class="icon-home"></i>
                        Home</Link>
                    {this.props.viewinfo.path &&
                    <Link className="current" to={this.props.viewinfo.path}>
                        {this.props.viewinfo.name}
                    </Link>}
                </div>
            </div>
        )
    }
}

Breadcrumb.propTypes = {
    viewinfo: PropTypes.object.isRequired,
    actions: PropTypes.object.isRequired
};

function mapStateToProps(state) {
    return {viewinfo: state.viewinfo};
}

function mapDispatchToProps(dispatch) {
    return {
        actions: bindActionCreators(PActions, dispatch)
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Breadcrumb);
