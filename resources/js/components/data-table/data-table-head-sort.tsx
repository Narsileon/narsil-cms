import type { Model } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import { Icon } from "@narsil-ui/components/icon";
import { useLocalization } from "@narsil-ui/components/localization";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { Header } from "@tanstack/react-table";
import { type ComponentProps } from "react";

type DataTableHeadSortProps = ComponentProps<typeof Button> & {
  header: Header<Model, unknown>;
};

function DataTableHeadSort({ className, header, ...props }: DataTableHeadSortProps) {
  const { trans } = useLocalization();

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

  const label = trans("accessibility.sort_column");

  return (
    <Tooltip tooltip={label}>
      <Button
        aria-label={label}
        className={className}
        size="icon"
        variant="ghost-secondary"
        onClick={header.column.getToggleSortingHandler()}
        {...props}
      >
        <Icon className="size-4" name={getIconName()} />
      </Button>
    </Tooltip>
  );
}

export default DataTableHeadSort;
