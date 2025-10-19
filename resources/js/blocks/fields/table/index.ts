import Table from "./table";
import TableItem from "./table-item";

type TableElement = Record<string, string> & {
  uuid: string;
};

export { Table, TableItem };

export type { TableElement };
