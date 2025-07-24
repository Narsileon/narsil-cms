import { Button } from "@narsil-cms/components/ui/button";
import { ChevronDown, ChevronsUpDown, ChevronUp } from "lucide-react";
import { Header } from "@tanstack/react-table";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";

type DataTableHeadSortProps = React.ComponentProps<typeof Button> & {
  header: Header<any, any>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { getLabel } = useLabels();

  const isSorted = header.column.getIsSorted();

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
        {isSorted === "asc" ? (
          <ChevronUp className="size-4" />
        ) : isSorted === "desc" ? (
          <ChevronDown className="size-4" />
        ) : (
          <ChevronsUpDown className="size-4" />
        )}
      </Button>
    </Tooltip>
  );
}

export default DataTableHeadSort;
