import { Trigger } from "@radix-ui/react-dialog";

export type SheetTriggerProps = React.ComponentProps<typeof Trigger> & {};

function SheetTrigger({ ...props }: SheetTriggerProps) {
  return <Trigger data-slot="sheet-trigger" {...props} />;
}

export default SheetTrigger;
