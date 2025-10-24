// https://ui.shadcn.com/docs/components/data-table

import getBulletColumn from "./columns/bullet-column";
import getMenuColumn from "./columns/menu-column";
import getSelectColumn from "./columns/select-column";
import DataTableColumns from "./data-table-columns";
import useDataTable from "./data-table-context";
import DataTableFilterDropdown from "./data-table-filter-dropdown";
import DataTableFilterItem from "./data-table-filter-item";
import DataTableFilterList from "./data-table-filter-list";
import DataTableFooter from "./data-table-footer";
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
  DataTableColumns,
  DataTableFilterDropdown,
  DataTableFilterItem,
  DataTableFilterList,
  DataTableFooter,
  DataTableHead,
  DataTableHeadSort,
  DataTableInput,
  DataTableProvider,
  DataTableRow,
  DataTableRowMenu,
  getBulletColumn,
  getMenuColumn,
  getSelectColumn,
  useDataTable,
};
