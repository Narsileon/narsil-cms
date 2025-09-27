import { Row } from "@tanstack/react-table";
import { type ComponentProps } from "react";

import { Checkbox } from "@narsil-cms/blocks/inputs";

type DataTableRowSelectProps = ComponentProps<typeof Checkbox> & {
  row: Row<unknown>;
};

function DataTableRowSelect({ row, ...props }: DataTableRowSelectProps) {
  return <Checkbox checked={row.getIsSelected()} {...props} />;
}

export default DataTableRowSelect;
