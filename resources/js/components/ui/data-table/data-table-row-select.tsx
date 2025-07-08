import { Checkbox } from "@/components/ui/checkbox";
import { Row } from "@tanstack/react-table";

type DataTableRowSelectProps = React.ComponentProps<typeof Checkbox> & {
  row: Row<any>;
};

function DataTableRowSelect({ row, ...props }: DataTableRowSelectProps) {
  return <Checkbox checked={row.getIsSelected()} {...props} />;
}

export default DataTableRowSelect;
