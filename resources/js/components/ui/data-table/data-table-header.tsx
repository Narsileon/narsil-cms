import * as React from "react";
import { TableHeader } from "@narsil-cms/components/ui/table";

type DataTableHeaderProps = React.ComponentProps<typeof TableHeader> & {};

function DataTableHeader({ ...props }: DataTableHeaderProps) {
  return <TableHeader data-slot="data-table-header" {...props} />;
}

export default DataTableHeader;
