import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import { ModalLink } from "@/components/ui/modal";
import { Tooltip } from "@/components/ui/tooltip";
import useTranslationsStore from "@/stores/translations-store";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  Section,
  SectionContent,
  SectionFooter,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import {
  DeleteIcon,
  EditIcon,
  MoreHorizontalIcon,
  PlusIcon,
} from "lucide-react";
import type { CategoriesCollection } from "@/types/global";

type CategoriesBlockProps = React.ComponentProps<typeof Section> &
  CategoriesCollection & {};

function CategoriesBlock({ data, meta, ...props }: CategoriesBlockProps) {
  const { trans } = useTranslationsStore();

  return (
    <Section {...props}>
      <SectionHeader className="flex items-center justify-between gap-4">
        <SectionTitle level="h2">{trans("ui.groups", "Groups")}</SectionTitle>
        <Tooltip tooltip={trans("ui.create", "Create")}>
          <Button asChild={true} size="icon">
            <ModalLink href={meta.create_href}>
              <PlusIcon />
            </ModalLink>
          </Button>
        </Tooltip>
      </SectionHeader>
      <SectionContent>
        <ul className="grid gap-2">
          {data.map((category) => (
            <li
              className="flex items-center justify-between gap-2"
              key={category.id}
            >
              <Button className="grow justify-start" variant="ghost">
                {category.label}
              </Button>
              <DropdownMenu>
                <DropdownMenuTrigger asChild>
                  <Button size="icon" variant="ghost">
                    <MoreHorizontalIcon className="h-4 w-4" />
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                  <DropdownMenuItem asChild={true}>
                    <ModalLink href={category.edit_href}>
                      <EditIcon />
                      {trans("ui.edit", "Edit")}
                    </ModalLink>
                  </DropdownMenuItem>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem asChild={true}>
                    <Link
                      as="button"
                      href={category.destroy_href}
                      method="delete"
                      data={{
                        _back: true,
                      }}
                    >
                      <DeleteIcon />
                      {trans("ui.delete", "Delete")}
                    </Link>
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            </li>
          ))}
        </ul>
      </SectionContent>
      <SectionFooter></SectionFooter>
    </Section>
  );
}

export default CategoriesBlock;
