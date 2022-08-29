import React from 'react';

export default function (props) {
    const { data, children } = props;

    return (
        <div className="table-responsive">
            <table className="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>{data.map(children)}</tbody>
            </table>
        </div>
    );
}
