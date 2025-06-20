import { Root } from "@radix-ui/react-dialog";

export type DialogProps = React.ComponentProps<typeof Root> & {};

function Dialog({ ...props }: DialogProps) {
  return <Root data-slot="dialog" {...props} />;
}

export default Dialog;
