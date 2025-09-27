// https://ui.shadcn.com/docs/components/data-table

import DataTableCell from "./data-table-cell";
import useDataTable from "./data-table-context";
import DataTableFilter from "./data-table-filter";
import DataTableFilterBadge from "./data-table-filter-badge";
import DataTableFilterDropdown from "./data-table-filter-dropdown";
import DataTableHead from "./data-table-head";
import DataTableHeadSort from "./data-table-head-sort";
import DataTableInput from "./data-table-input";
import DataTableProvider from "./data-table-provider";
import DataTableRow from "./data-table-row";
import DataTableRowMenu from "./data-table-row-menu";
import DataTableRowSelect from "./data-table-row-select";

export type ColumnFilter = {
  column: string;
  operator: string;
  value: string | number;
};

export {
  DataTableCell,
  DataTableFilter,
  DataTableFilterBadge,
  DataTableFilterDropdown,
  DataTableHead,
  DataTableHeadSort,
  DataTableInput,
  DataTableProvider,
  DataTableRow,
  DataTableRowMenu,
  DataTableRowSelect,
  useDataTable,
};
