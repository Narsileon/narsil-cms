import { Checkbox } from "@/components/ui/checkbox";
import { Row } from "@tanstack/react-table";
import type { CheckboxProps } from "@/components/ui/checkbox";

export type DataTableRowSelectProps = CheckboxProps & {
  row: Row<any>;
};

function DataTableRowAction({ row, ...props }: DataTableRowSelectProps) {
  return <Checkbox checked={row.getIsSelected()} {...props} />;
}

export default DataTableRowAction;
