import { Group } from "@radix-ui/react-menubar";

export type MenubarGroupProps = React.ComponentProps<typeof Group> & {};

function MenubarGroup({ ...props }: MenubarGroupProps) {
  return <Group data-slot="menubar-group" {...props} />;
}

export default MenubarGroup;
