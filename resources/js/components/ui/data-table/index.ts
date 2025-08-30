// https://ui.shadcn.com/docs/components/data-table

import DataTable from "./data-table";
import DataTableBody from "./data-table-body";
import DataTableCell from "./data-table-cell";
import DataTableFilter from "./data-table-filter";
import DataTableFilterBadge from "./data-table-filter-badge";
import DataTableFilterDropdown from "./data-table-filter-dropdown";
import DataTableHead from "./data-table-head";
import DataTableHeader from "./data-table-header";
import DataTableHeadMove from "./data-table-head-move";
import DataTableHeadSort from "./data-table-head-sort";
import DataTableInput from "./data-table-input";
import DataTablePagination from "./data-table-pagination";
import DataTableProvider from "./data-table-provider";
import DataTableRow from "./data-table-row";
import DataTableRowMenu from "./data-table-row-menu";
import DataTableRowSelect from "./data-table-row-select";
import DataTableSize from "./data-table-size";
import DataTableVisibilityDropdown from "./data-table-visibility-dropdown";
import useDataTable from "./data-table-context";

export type ColumnFilter = {
  column: string;
  operator: string;
  value: string | number;
};

export {
  DataTable,
  DataTableBody,
  DataTableCell,
  DataTableFilter,
  DataTableFilterBadge,
  DataTableFilterDropdown,
  DataTableHead,
  DataTableHeader,
  DataTableHeadMove,
  DataTableHeadSort,
  DataTableInput,
  DataTablePagination,
  DataTableProvider,
  DataTableRow,
  DataTableRowMenu,
  DataTableRowSelect,
  DataTableSize,
  DataTableVisibilityDropdown,
  useDataTable,
};
