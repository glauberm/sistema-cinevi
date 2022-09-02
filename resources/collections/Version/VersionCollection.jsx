import { Link } from 'react-router-dom';

import { getDate, getTime } from '../../services/datetime';
import PaginatedList from '../../components/Collections/PaginatedList';

export default function (props) {
    const { paginate, data, links, meta, linkToPrefix } = props;

    return (
        <PaginatedList
            listFn={paginate}
            data={data}
            links={links}
            meta={meta}
            headers={['Data e hora', 'Mensagem', 'Autor(a)']}
            row={(revision) => (
                <tr key={revision.id}>
                    <td>
                        <Link to={`/${linkToPrefix}/historico/${revision.id}`}>
                            {`${getDate(revision.datetime)} às ${getTime(revision.datetime)}`}
                        </Link>
                    </td>
                    <td>{revision.message}</td>
                    <td>
                        {revision.user.id ? (
                            <Link to={`/usuarios/${revision.user.id}`}>{revision.user.email}</Link>
                        ) : (
                            <span>{revision.user}</span>
                        )}
                    </td>
                </tr>
            )}
        />
    );
}
