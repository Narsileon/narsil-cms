// https://ui.shadcn.com/docs/components/data-table

import DataTableBody from "./data-table-body";
import DataTableCell from "./data-table-cell";
import useDataTable from "./data-table-context";
import DataTableFilter from "./data-table-filter";
import DataTableFilterBadge from "./data-table-filter-badge";
import DataTableFilterDropdown from "./data-table-filter-dropdown";
import DataTableHead from "./data-table-head";
import DataTableHeadMove from "./data-table-head-move";
import DataTableHeadSort from "./data-table-head-sort";
import DataTableHeader from "./data-table-header";
import DataTableInput from "./data-table-input";
import DataTableProvider from "./data-table-provider";
import DataTableRoot from "./data-table-root";
import DataTableRow from "./data-table-row";
import DataTableRowMenu from "./data-table-row-menu";
import DataTableRowSelect from "./data-table-row-select";
import DataTableSize from "./data-table-size";
import DataTableVisibilityDropdown from "./data-table-visibility-dropdown";

export type ColumnFilter = {
  column: string;
  operator: string;
  value: string | number;
};

export {
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
  DataTableProvider,
  DataTableRoot,
  DataTableRow,
  DataTableRowMenu,
  DataTableRowSelect,
  DataTableSize,
  DataTableVisibilityDropdown,
  useDataTable,
};
