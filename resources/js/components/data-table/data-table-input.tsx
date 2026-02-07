import { Icon } from "@narsil-ui/components/icon";
import { InputContent } from "@narsil-ui/components/input";
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from "@narsil-ui/components/input-group";
import { useTranslator } from "@narsil-ui/components/translator";
import { type ComponentProps } from "react";
import useDataTable from "./data-table-context";

type DataTableInputProps = ComponentProps<typeof InputContent>;

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { trans } = useTranslator();

  const { dataTableStore } = useDataTable();

  return (
    <InputGroup>
      <InputGroupAddon>
        <Icon name="search" />
      </InputGroupAddon>
      <InputGroupInput
        placeholder={trans("placeholders.search")}
        value={dataTableStore.search ?? ""}
        onChange={(event) => dataTableStore.setSearch(event.target.value)}
        {...props}
      />
      {dataTableStore.search ? (
        <InputGroupAddon align="inline-end">
          <InputGroupButton size="icon-sm">
            <Icon name="x" onClick={() => dataTableStore.setSearch(null)} />
          </InputGroupButton>
        </InputGroupAddon>
      ) : null}
    </InputGroup>
  );
}

export default DataTableInput;
