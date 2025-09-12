import { Button } from "@narsil-cms/components/button";
import { Header } from "@tanstack/react-table";
import { Icon } from "@narsil-cms/components/icon";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type DataTableHeadSortProps = React.ComponentProps<typeof Button> & {
  header: Header<any, any>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { trans } = useLabels();

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
    <Tooltip tooltip={trans("accessibility.sort_column")}>
      <Button
        aria-label={trans("accessibility.sort_column", "Sort column")}
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
