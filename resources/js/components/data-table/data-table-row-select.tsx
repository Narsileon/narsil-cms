import { Row } from "@tanstack/react-table";

import { Checkbox } from "@narsil-cms/components/checkbox";

type DataTableRowSelectProps = React.ComponentProps<typeof Checkbox> & {
  row: Row<any>;
};

function DataTableRowSelect({ row, ...props }: DataTableRowSelectProps) {
  return <Checkbox checked={row.getIsSelected()} {...props} />;
}

export default DataTableRowSelect;
