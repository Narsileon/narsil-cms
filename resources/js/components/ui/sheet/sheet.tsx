import { Root } from "@radix-ui/react-dialog";

export type SheetProps = React.ComponentProps<typeof Root> & {};

function Sheet({ ...props }: SheetProps) {
  return <Root data-slot="sheet" {...props} />;
}

export default Sheet;
