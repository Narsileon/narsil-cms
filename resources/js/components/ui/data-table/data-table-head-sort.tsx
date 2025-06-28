import { Button } from "@/components/ui/button";
import { ChevronDown, ChevronsUpDown, ChevronUp } from "lucide-react";
import { Header } from "@tanstack/react-table";
import useTranslationsStore from "@/stores/translations-store";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import type { ButtonProps } from "@/components/ui/button";

export type DataTableHeadSortProps = ButtonProps & {
  header: Header<any, any>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { trans } = useTranslationsStore();

  const isSorted = header.column.getIsSorted();

  return (
    <Tooltip>
      <TooltipTrigger asChild={true}>
        <Button
          aria-label={trans("tooltips.column.sort")}
          size="icon"
          variant="ghost"
          onClick={header.column.getToggleSortingHandler()}
          {...props}
        >
          {isSorted === "asc" ? (
            <ChevronUp />
          ) : isSorted === "desc" ? (
            <ChevronDown />
          ) : (
            <ChevronsUpDown />
          )}
        </Button>
      </TooltipTrigger>
      <TooltipContent>{trans("tooltips.column.sort")}</TooltipContent>
    </Tooltip>
  );
}

export default DataTableHeadSort;
