import { Sub } from "@radix-ui/react-menubar";

export type MenubarSubProps = React.ComponentProps<typeof Sub> & {};

function MenubarSub({ ...props }: MenubarSubProps) {
  return <Sub data-slot="menubar-sub" {...props} />;
}

export default MenubarSub;
