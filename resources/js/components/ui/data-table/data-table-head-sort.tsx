import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { Header } from "@tanstack/react-table";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type DataTableHeadSortProps = React.ComponentProps<typeof Button> & {
  header: Header<any, any>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { getLabel } = useLabels();

  function getIconName() {
    switch (header.column.getIsSorted()) {
      case "asc":
        return "chevron-up";
      case "desc":
        return "chevron-down";
      default:
        return "chevrons-up-down";
    }
  }

  return (
    <Tooltip tooltip={getLabel("accessibility.sort_column")}>
      <Button
        aria-label={getLabel("accessibility.sort_column", "Sort column")}
        className="size-6"
        size="icon"
        variant="ghost"
        onClick={header.column.getToggleSortingHandler()}
        {...props}
      >
        <Icon className="size-4" name={getIconName()} />
      </Button>
    </Tooltip>
  );
}

export default DataTableHeadSort;
