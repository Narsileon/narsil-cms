// https://ui.shadcn.com/docs/components/data-table

import DataTableCell from "./data-table-cell";
import DataTableColumns from "./data-table-columns";
import useDataTable from "./data-table-context";
import DataTableFilterDropdown from "./data-table-filter-dropdown";
import DataTableFilterItem from "./data-table-filter-item";
import DataTableFilterList from "./data-table-filter-list";
import DataTableHead from "./data-table-head";
import DataTableHeadSort from "./data-table-head-sort";
import DataTableInput from "./data-table-input";
import DataTableProvider from "./data-table-provider";
import DataTableRow from "./data-table-row";
import DataTableRowMenu from "./data-table-row-menu";

export type ColumnFilter = {
  column: string;
  operator: string;
  value: string | number;
};

export {
  DataTableCell,
  DataTableColumns,
  DataTableFilterDropdown,
  DataTableFilterItem,
  DataTableFilterList,
  DataTableHead,
  DataTableHeadSort,
  DataTableInput,
  DataTableProvider,
  DataTableRow,
  DataTableRowMenu,
  useDataTable,
};
